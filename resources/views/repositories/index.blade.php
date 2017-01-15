@extends('layouts.app')


@section('title', 'Repositories')

@section('content')
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Repositories
                </header>
                <div class="panel-body">
                    <section id="unseen">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Owner</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($repositories as $repository)
                                <tr>
                                    <td>
                                        <a href="/repositories/{{ $repository['full_name'] }}">{{ $repository['full_name'] }}</a>
                                    </td>
                                    <td>
                                        <img src="{{ $repository['owner']['avatar_url'] }}" width="20" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>
            </section>
        </div>
    </div>
@endsection
