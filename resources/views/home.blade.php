@extends('layouts.app')

@section('title', 'Home dashboard')

@section('content')
    <h1>Organizations</h1>

    @foreach ($organizations->chunk(3) as $organizationsChunk)
        <div class="row">
            @foreach ($organizationsChunk as $organization)
            <div class="col-lg-4">
                <!--widget start-->
                <aside class="profile-nav alt weather-border">
                    <section class="panel">
                        <div class="user-heading alt weather-bg">
                            <a href="/repositories/organization/{{ $organization['login'] }}">
                                <img alt="Logo for organization {{ $organization['login'] }}" src="{{ $organization['avatar_url'] }}">
                            </a>
                            <h1>{{ !empty($organization['name']) ? $organization['name']: $organization['login'] }}</h1>
                            {{ !empty($organization['blog']) ? $organization['blog']: '' }}
                        </div>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="javascript:;"> <i class="fa fa-clock-o"></i> Public repositories <span class="label label-primary pull-right r-activity">{{ $organization['public_repos'] }}</span></a></li>
                            <li><a href="javascript:;"> <i class="fa fa-calendar"></i> Created <span class="label label-success pull-right r-activity">{{ $organization['created_at'] }}</span></a></li>
                        </ul>
                    </section>
                </aside>
                <!--widget end-->
            </div>
            @endforeach
        </div>
    @endforeach
@endsection
