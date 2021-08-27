@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Latest Categories</div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" width="60"> # </td>
                                <td scope="col" width="60"> Name </td>
                                <td scope="col" width="200"> Created By </td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $sn = 0;
                            ?>
                            @foreach( $categories as $category )
                                <?php
                                    $sn += 1;
                                ?>
                                <tr>
                                    <td> {{ $sn }} </td>
                                    <td> {{ $category->name }} </td>
                                    <td> {{ $category->user->name }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Latest Posts</div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" width="60"> # </td>
                                <td scope="col" width="60"> Title </td>
                                <td scope="col" width="200"> Created By </td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Latest Pages</div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <td scope="col" width="60"> # </td>
                                <td scope="col" width="60"> Title </td>
                                <td scope="col" width="200"> Created By </td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $sn = 0;
                            ?>
                            @foreach( $pages as $page )
                                <?php
                                    $sn += 1;
                                ?>
                                <tr>
                                    <td> {{ $sn }} </td>
                                    <td> {{ $page->title }} </td>
                                    <td> {{ $page->user->name }} </td>
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
