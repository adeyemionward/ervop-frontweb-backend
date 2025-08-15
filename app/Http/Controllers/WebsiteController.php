<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.index');
    }
    public function about()
    {
        return view('website.about');
    }
    public function appointment()
    {
        return view('website.appointment');
    }
    public function services()
    {
        return view('website.services');
    }
    public function service_detail()
    {
        return view('website.service_detail');
    }   
    public function shop()
    {
        return view('website.shop');
    }
    public function product_detail()
    {
        return view('website.product_detail');
    }       
    public function product_link()
    {
        return view('website.product_link');
    }
    public function project_link()
    {
        return view('website.project_link');
    }   

    public function whyus()
    {
        return view('website.whyus');
    }
    public function terms()
    {
        return view('website.terms');   
    }
    public function privacy()
    {
        return view('website.privacy');
    }
    public function contact()
    {
        return view('website.contact');
    }   

    public function faq()
    {
        return view('website.faq');
    }

    public function portfolio()
    {
        return view('website.portfolio');
    }

    

}
