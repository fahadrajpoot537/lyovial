<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search', $request->input('q'));

        $inquiries = ContactInquiry::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(ContactInquiry $inquiry): View
    {
        if ($inquiry->isUnread()) {
            $inquiry->markAsRead();
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, ContactInquiry $inquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,read,archived'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($data['status'] === ContactInquiry::STATUS_READ && ! $inquiry->read_at) {
            $data['read_at'] = now();
        }

        if ($data['status'] === ContactInquiry::STATUS_NEW) {
            $data['read_at'] = null;
        }

        $inquiry->update($data);

        return back()->with('success', 'Inquiry updated successfully.');
    }

    public function destroy(ContactInquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()
            ->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }

    public function markRead(ContactInquiry $inquiry): RedirectResponse
    {
        $inquiry->markAsRead();

        return back()->with('success', 'Inquiry marked as read.');
    }

    public function markUnread(ContactInquiry $inquiry): RedirectResponse
    {
        $inquiry->markAsUnread();

        return back()->with('success', 'Inquiry marked as unread.');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filename = 'contact-inquiries-'.now()->format('Y-m-d-His').'.csv';

        $search = $request->input('search', $request->input('q'));

        $query = ContactInquiry::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest();

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Company', 'Message', 'Status', 'IP', 'Created At', 'Notes']);

            $query->chunk(200, function ($inquiries) use ($handle): void {
                foreach ($inquiries as $inquiry) {
                    fputcsv($handle, [
                        $inquiry->id,
                        $inquiry->name,
                        $inquiry->email,
                        $inquiry->phone,
                        $inquiry->company,
                        $inquiry->message,
                        $inquiry->status,
                        $inquiry->ip_address,
                        $inquiry->created_at?->toDateTimeString(),
                        $inquiry->notes,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
