<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessage;
use App\Message;
use App\Project;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function index(Project $project): View
    {
        return view('messages.index', [
            'project' => $project,
        ]);
    }

    public function create(Project $project): View
    {
        return view('messages.form', [
            'project' => $project,
        ]);
    }

    public function store(StoreMessage $request, Project $project): Response
    {
        $message = new Message();
        $message->name = $request->name;
        $message->description = $request->description;
        $message->type = $request->type;
        $message->project_id = $project->id;
        $message->save();

        return redirect()->route('messages.index', $project)
            ->with('success', "Added <b>$message->name</b> successfully.");
    }

    public function edit(Project $project, Message $message): View
    {
        return view('messages.form', [
            'project' => $project,
            'message' => $message,
        ]);
    }

    public function update(StoreMessage $request, Project $project, Message $message): Response
    {
        $message->name = $request->name;
        $message->description = $request->description;
        $message->save();

        return redirect()->route('messages.index', $project)
            ->with('success', "Updated <b>$message->name</b> successfully.");
    }

    public function destroy(Project $project, Message $message): Response
    {
        $message->delete();

        return redirect()->route('messages.index', $project)
            ->with('success', "Deleted <b>$message->name</b> successfully.");
    }
}