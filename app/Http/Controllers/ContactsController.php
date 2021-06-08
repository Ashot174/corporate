<?php

namespace App\Http\Controllers;

use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactsController extends SiteController
{
    //
    public function __construct(MenusRepository $m_rep)
    {
        parent::__construct($m_rep);

        $this->bar = 'left';
        $this->template = env('THEME').'.contacts';
    }


    public function index(Request $request){

        if ($request->isMethod('post')){
            $messages = [
                'required'=>'Поле :attribute обязательно к заполнению',
                'email'=>'Поле :attribute должен содержать правильный имейл'
            ];
            $this->validate($request,[
                'name'=>'required|max:255',
                'email'=>'required|email',
                'text'=>'required'
            ],$messages);
            $data = $request->all();

            $result = Mail::send(env('THEME').'.email',['data'=>$data], function ($m) use ($data){
                $mail_admin = env('MAIL_USERNAME');
                $m->from($data['email'], $data['name']);
                $m->to($mail_admin,'Mr. Admin')->subject('Question');
            });

            if ($result){
                return redirect()->route('contacts')->with('status','Email is send');
            }
        }

        $this->title = 'Контакты';

        $content = view(env('THEME').'.contact_content')->render();
        $this->vars['content'] = $content;

        $this->contentLeftBar = view(env('THEME').'.contact_bar')->render();

        return $this->renderOutput();
    }
}
