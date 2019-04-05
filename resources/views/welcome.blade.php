@extends('layouts.app')
@section('content')
    

    <div class="hero">
        <div class="container-nm">
            <h1>Boilerplate Laravel 5.8</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="column column-75">
                <h3>What's is this ?</h3>
                <hr>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A molestias saepe dignissimos assumenda perspiciatis, explicabo provident ratione possimus nesciunt facere quo cumque. Itaque ullam quia in tenetur optio iusto ducimus!</p>
            </div>
            <div class="column column-25">
                <h3>Links</h3>
                <hr>
                <ul>
                    <li><a href="">Link</a></li>
                    <li><a href="">Link</a></li>
                    <li><a href="">Link</a></li>
                    <li><a href="">Link</a>
                        <ul>
                            <li><a href="">link</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
@endsection