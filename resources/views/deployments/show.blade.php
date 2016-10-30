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
    </div>
    <div class="col-lg-9">
        <section class="panel">
            @if($deployment['description'])
                <div class="bio-graph-heading">
                    {{ $deployment['description'] }}
                </div>
            @endif
            <div class="panel-body bio-graph-info">
                <h1>Deployment details</h1>
                <div class="row">
                    <div class="bio-row">
                        <p><span>Task </span>: {{ $deployment['task'] }}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Ref </span>: {{ $deployment['ref'] }}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Environment </span>: {{ $deployment['environment'] }}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Commit</span>: {{ $deployment['sha'] }}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Created </span>: {{ $deployment['created_at'] }}</p>
                    </div>
                    <div class="bio-row">
                        <p>
                            <span>Creator </span>: <img src="{{ $deployment['creator']['avatar_url'] }}" width="20" class="img-rounded" /> {{ $deployment['creator']['login'] }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">
                Deployment steps
            </header>
            <div class="panel-body">
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Creation date</th>
                            <th>State</th>
                            <th>Creator</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($statuses as $status)
                            <tr>
                                <td>
                                    {{ $status['created_at'] }}
                                </td>
                                <td>{{ $status['state'] }}</td>
                                <td><img src="{{ $status['creator']['avatar_url'] }}" width="20" class="img-rounded" /> {{ $status['creator']['login'] }}</td>
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
