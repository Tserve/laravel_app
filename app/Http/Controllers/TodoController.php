<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Illuminate\Support\Facades\DB;
use Auth;

class TodoController extends Controller
{
    private $todo;
    public function __construct(Todo $instanceClass)
    {
        $this->middleware('auth');
        $this->todo = $instanceClass;
    }
    /**
     * Display a listing of the resource.
     * todo一覧ページへレンダリング処理
     * レンダリング時にtodo一覧が格納されている$todoをindex.bladeへ送りblade内で表示処理
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->getByUserId(Auth::id());
        return view('todo.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     * * todo新規作成ページへレンダリング処理
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     * * 新規作成されたtodoのデータベース登録処理とtodo一覧ページへのリダイレクト処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->todo->fill($input)->save();
        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * * 編集するtodoのidを取得して対象のtodoをデータベースで取得
     * レンダリング時に対象のtodoをedit.bladeへ送りblade内で表示処理
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->todo->find($id);
        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     * 編集されたtodoをデータベース更新処理をして一覧ページへリダイレクト
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $input = $request->all();
        $this->todo->find($id)->fill($input)->save();
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     * 削除対象のtodoのidを取得してデータベースの削除処理をして、一覧ページへリダイレクト
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todo->find($id)->delete();
        return redirect()->route('todo.index');
    }
}
