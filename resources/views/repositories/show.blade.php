@extends('layouts.app')

@section('title', $repository['full_name'] )

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-3">
        <div class="media">
            <div class="media-left">
                <a href="#">
                    <img class="media-object img-rounded" src="{{ $repository['owner']['avatar_url'] }}" width="37px" alt="{{ $repository['owner']['avatar_url'] }} logo">
                </a>
            </div>
            <div class="media-body">
                <h3 class="media-heading drg-event-title">{{ $repository['name'] }}</h3>
                <p>{{ $repository['description'] }}</p>
            </div>
        </div>
        <p><button type="button" class="btn btn-primary btn-lg"><i class="fa fa-send"></i> New deployment</button></p>
    </div>
    <div class="col-lg-9">
        <section class="panel">
            <header class="panel-heading">
                Deployments
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
                                    <a href="/deployments/{{ $repository['full_name'] }}/{{ $deployment['id'] }}">
                                        <i class="fa fa-bookmark-o"></i> {{ date('H:i d-m-Y', strtotime($deployment['created_at'])) }}
                                    </a>
                                </td>
                                <td>{{ $deployment['task'] }}</td>
                                <td>{{ $deployment['environment'] }}</td>
                                <td>{{ $deployment['ref'] }}</td>
                                <td>{{ $deployment['description'] }}</td>
                                <td><img src="{{ $deployment['creator']['avatar_url'] }}" width="20" class="img-rounded" /></td>
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
