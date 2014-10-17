<?php

class NerdsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /nerds
	 *
	 * @return Response
	 */
	public function index()
	{
		//get all the nerds
		$nerds = Nerd::all();

		//load the view and pass the nerds
		return View::make('nerds.index')->with('nerds', $nerds);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /nerds/create
	 *
	 * @return Response
	 */
	public function create()
	{
		// load the create from app/views/nerds/create.blade.php
		return View::make('nerds.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /nerds
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name' => 'required',
			'email' => 'required|email', 
			'nerd_level' => 'required|numeric' 
		);

		$validator = Validator::make(Input::all(),$rules);

		//process the login
		if ($validator->fails()) {
			return Redirect::to('nerds.create')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store
			$nerd = new Nerd;
			$nerd->name = Input::get('name');
			$nerd->email = Input::get('email');
			$nerd->nerd_level = Input::get('nerd_level');
			$nerd->save();

			// redirect
			Session::flash('message', 'Successfully created nerd!');
			return Redirect::to('nerds');

		}
	}

	/**
	 * Display the specified resource.
	 * GET /nerds/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// get the nerd
		$nerd = Nerd::find($id);

		// show the view and pass the nerd to it
		return View::make('nerds.show')->with('nerd', $nerd);

	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /nerds/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the nerd
		$nerd = Nerd::find($id);

		// show the edit form and pass the nerd
		return View::make('nerds.edit')->with('nerd', $nerd);

	}

	/**
	 * Update the specified resource in storage.
	 * PUT /nerds/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		$rules = array(
			'name' => 'required',
			'email' => 'required|email', 
			'nerd_level' => 'required|numeric' 
		);
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::to('nerds/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
			$nerd = Nerd::find($id);
            $nerd->name       = Input::get('name');
            $nerd->email      = Input::get('email');
            $nerd->nerd_level = Input::get('nerd_level');
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully updated nerd!');
            return Redirect::to('nerds');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /nerds/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
        $nerd = Nerd::find($id);
        $nerd->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the nerd!');
        return Redirect::to('nerds');
	}

}