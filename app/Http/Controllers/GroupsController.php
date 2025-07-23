<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jobgroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\Group;

class GroupsController extends Controller {

	/*
	 * Display a listing of groups
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = Group::where('organization_id',Auth::user()->organization_id)->get();
		Log::info('Fetched groups: ' . $groups->count() . ' records for organization_id: ' . Auth::user()->organization_id);
		return view('groups.index', compact('groups'));
	}

	/*
	 * Show the form for creating a new group
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('groups.create');
	}

	/*
	 * Store a newly created group in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Group::$rules, [
            'name.required' => 'Group name is required.',
        ]);

        if ($validator->fails()) {
            Log::error('Group validation failed: ' . json_encode($validator->errors()));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $group = new Group;
            $group->name = $request->input('name');
            $group->description = $request->input('description');
            $group->organization_id = Auth::user()->organization_id ?? 1;
            $group->save();
            Log::info('Group created: ' . $group->name);
            return Redirect::route('groups.index')->with('success', 'Group created successfully!');
        } catch (\Exception $e) {
            Log::error('Group creation failed: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Failed to create group: ' . $e->getMessage())->withInput();
        }
    }

	/*
	 * Display the specified group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$group = Group::findOrFail($id);

		return view('groups.show', compact('group'));
	}

	/*
	 * Show the form for editing the specified group.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
    {
        $group = Group::findOrFail($id);
        return View::make('groups.edit', compact('group'));
    }

	/*
	 * Update the specified group in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Group::$rules, [
            'name.required' => 'Group name is required.',
        ]);

        if ($validator->fails()) {
            Log::error('Group update validation failed: ' . json_encode($validator->errors()));
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $group = Group::findOrFail($id);
            $group->name = $request->input('name');
            $group->description = $request->input('description');
            $group->organization_id = Auth::user()->organization_id ?? 1;
            $group->save();
            Log::info('Group updated: ' . $group->name);
            return Redirect::route('groups.index')->with('success', 'Group updated successfully!');
        } catch (\Exception $e) {
            Log::error('Group update failed: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Failed to update group: ' . $e->getMessage())->withInput();
        }
    }

	/*
	 * Remove the specified group from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
public function destroy($id)
    {
        try {
            Group::destroy($id);
            Log::info('Group deleted: ID ' . $id);
            return Redirect::route('groups.index')->with('success', 'Group deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Group deletion failed: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Failed to delete group: ' . $e->getMessage());
        }
    }
}
