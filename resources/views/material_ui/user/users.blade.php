@extends('material_ui.layouts.app')

@section('content')

<div class="container mx-auto px-4">
    @if (session('status'))
    <div class="bg-green-400 text-gray-900 px-2 py-1 rounded-lg" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex py-2 justify-end">
        <div>
            <a href="/user/add">
                <button type="button"
                    class="leading-tight bg-primary text-gray-200 rounded px-6 py-3 text-sm focus:outline-none focus:border-white float-right">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </button>
            </a>
        </div>
    </div>

    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-0">
            <h6 class="card-title card-padding pb-0">Users</h6>
            <div class="table-responsive">
                <table id="datatable" class="table table-hoverable">
                    <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Client</th>
                            @if(Auth::user()->is_admin == 1)
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <?php $i=1; ?>
                    <tbody>
                        @foreach($user_list as $user)
                        <tr>
                            <td style="text-align: center;">{{$i++}}</td>
                            <td style="text-align: center;">{{ $user->username }}</td>
                            <td style="text-align: center;">{{ $user->email }}</td>
                            @if(url('/') == 'http://localhost:8000' || url('/') ==
                            'https://creative.planetnine.com')
                            <td style="text-align: center;">{{ $user->logoname }}</td>
                            @endif
                            @if(Auth::user()->is_admin == 1)
                                <td style="text-align: center;">
                                    @if($user->is_admin == 1)
                                    <span class="mdc-button mdc-button--raised filled-button--secondary">
                                        Admin
                                    </span>
                                    @else
                                    <span class="mdc-button mdc-button--raised filled-button--success">
                                        User
                                    </span>
                                    @endif
                                </td>       
                                <td style="text-align: center;">
                                    <a href="/user/edit/{{$user->id}}">
                                        <button class="mdc-button mdc-button--raised filled-button--info">
                                            Edit
                                        </button>
                                    </a>
                                    <a href="/user/delete/{{$user->id}}"
                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                        <button
                                            class="mdc-button mdc-button--raised filled-button--warning">
                                            Delete
                                        </button>
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection