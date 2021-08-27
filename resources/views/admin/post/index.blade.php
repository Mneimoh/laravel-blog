@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">X</button>
                    {{ Session('message') }}
                </div>
            @endif

            @if (Session::has('delete-message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">X</button>
                    {{ Session('delete-message') }}
                </div>
            @endif

            @if (Session::has('update-message'))
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">X</button>
                    {{ Session('update-message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Post - list
                    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary float-right">Add New</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" width="60"> # </td>
                                <td scope="col"> Title </td>
                                <td scope="col" width="150"> Created By </td>
                                <td scope="col" width="129"> Action </td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $sn = 0;
                            ?>
                            @foreach( $posts as $post )
                                <?php
                                    $sn += 1;
                                ?>
                                <tr>
                                    <td> {{ $sn }} </td>
                                    <td> {{ $post->title }} </td>
                                    <td> {{ $post->user->name }} </td>
                                    <td> 
                                        <div class="row">
                                        <div class="col-sm-4">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a> 
                                        </div>
                                        <div class="col-sm-3">
                                        {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete', 'style' => 'display-inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                        {!! Form::close() !!}
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
