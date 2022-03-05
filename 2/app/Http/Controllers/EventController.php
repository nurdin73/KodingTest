<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *      path="/events",
     *      operationId="getEvents",
     *      tags={"Events"},
     *      summary="Get list of events",
     *      description="Returns list of events",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *  )
     *
     * Returns list of clients
     */
    public function index(Request $request)
    {
        $search = $request->input('search') ?? "";
        $events = Event::select('*');
        if($search != "") {
            $events = $events->where('name', 'like', "%$search%");
        } 
        $events = $events->orderBy('date', 'desc')->paginate(10);
        return EventResource::collection($events);
    }

    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
        ]);
        if($request->hasFile('thumbnail')) {
            $event['thumbnail'] = $request->file('thumbnail')->store('thumbnails', ['disk' => 'local']);
        }
        $event = Event::create($event);
        return response()->json(['message' => 'Event created'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
        ]);
        if($request->hasFile('thumbnail')) {
            if($event->thumbnail) {
                unlink(storage_path("app/$event->thumbnail"));
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails');
        }
        $event->update($data);
        return response()->json(['message' => 'Event updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}
