<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function create(): View
    {
        return view('kritik-saran');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'sender_type' => ['nullable', 'string', Rule::in(Feedback::SENDER_TYPES)],
            'message_type' => ['required', 'string', Rule::in(Feedback::MESSAGE_TYPES)],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'reply_contact' => ['nullable', 'string', 'max:255'],
        ], [
            'name.max' => __('ui.feedback.validation.max', ['field' => __('ui.feedback.field_name'), 'max' => 255]),
            'sender_type.in' => __('ui.feedback.validation.invalid', ['field' => __('ui.feedback.field_sender_type')]),
            'message_type.required' => __('ui.feedback.validation.required', ['field' => __('ui.feedback.field_message_type')]),
            'message_type.in' => __('ui.feedback.validation.invalid', ['field' => __('ui.feedback.field_message_type')]),
            'subject.required' => __('ui.feedback.validation.required', ['field' => __('ui.feedback.field_subject')]),
            'subject.max' => __('ui.feedback.validation.max', ['field' => __('ui.feedback.field_subject'), 'max' => 255]),
            'message.required' => __('ui.feedback.validation.required', ['field' => __('ui.feedback.field_message')]),
            'message.max' => __('ui.feedback.validation.max', ['field' => __('ui.feedback.field_message'), 'max' => 2000]),
            'reply_contact.max' => __('ui.feedback.validation.max', ['field' => __('ui.feedback.field_reply_contact'), 'max' => 255]),
        ]);

        Feedback::create([
            'name' => $validated['name'] ?? null,
            'sender_type' => $validated['sender_type'] ?? null,
            'message_type' => $validated['message_type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'reply_contact' => $validated['reply_contact'] ?? null,
            'is_read' => false,
        ]);

        return redirect()
            ->route('kritik-saran')
            ->with('success', __('ui.feedback.success_message'));
    }
}
