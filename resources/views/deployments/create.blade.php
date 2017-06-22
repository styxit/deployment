@extends('layouts.app')

@section('title', sprintf('Create new deployment for %s', $repository['name']))

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
                <h3 class="media-heading drg-event-title">
                    <a href="/repositories/{{ $repository['full_name'] }}">
                        {{ $repository['name'] }}
                    </a>
                </h3>
                <p>{{ $repository['description'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <section class="panel">
            <div class="bio-graph-heading"><i class="fa fa-send-o" aria-hidden="true"></i> New deployment</div>
            <header class="panel-heading">
                Deployment details
            </header>
            <div class="panel-body">
                <form role="form" method="post" action="/deployments/{{ $repository['full_name'] }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inputBranch">What?</label>
                        <select name="ref" class="form-control m-bot15" id="inputBranch">
                            <option>Select a branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch['name'] }}">{{ $branch['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputEnvironment">Where?</label>
                        <input name="environment" type="text" class="form-control" id="inputEnvironment" placeholder="Specify an environment (e.g., production, staging, dev). ">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="auto_merge" type="checkbox"> Auto-merge with default branch before deploying
                        </label>
                    </div>
                    <button type="submit" class="btn btn-info">Deploy</button>
                </form>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">Available branches</header>
            <div class="panel-body">
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Latest commit SHA</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($branches as $branch)
                            <tr>
                                <td>
                                    {{ $branch['name'] }}
                                    @if($branch['name'] === $repository['default_branch'])
                                        <span class="label label-info">Default branch</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="https://github.com/{{ $repository['full_name'] }}/commit/{{ $branch['commit']['sha'] }}" target="_blank">{{ $branch['commit']['sha'] }}</a>
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
