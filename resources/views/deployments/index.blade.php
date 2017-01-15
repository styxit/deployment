@extends('layouts.app')


@section('title', 'Deployments')

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Deployments for my repositories
            </header>
            <div class="panel-body">
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Creation date</th>
                            <th>Task</th>
                            <th>Environment</th>
                            <th>reference</th>
                            <th>Description</th>
                            <th>Creator</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($deployments as $deployment)
                            <tr>
                                <td>
                                    <a href="/deployments/{{ $deployment['repository']['full_name'] }}/{{ $deployment['id'] }}">
                                        <i class="fa fa-bookmark-o"></i> {{ date('H:i d-m-Y', strtotime($deployment['created_at'])) }}
                                    </a>
                                </td>
                                <td>{{ $deployment['task'] }}</td>
                                <td>{{ $deployment['environment'] }}</td>
                                <td>{{ $deployment['ref'] }}</td>
                                <td>{{ $deployment['description'] }}</td>
                                <td><img src="{{ $deployment['creator']['avatar_url'] }}" width="20" /></td>
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
