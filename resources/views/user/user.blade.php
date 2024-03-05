@extends('layouts.templates.dashboard')
@section('content-dashboard')
<a href=""></a>
<div class="card">
    <div class="card-body pt-3">
        <!-- Table with stripped rows -->
        <table class="table datatable ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <div class="d-flex gap-3">
                                @if ($item->roles_id !== 1)
                                    <div>
                                    <form action="{{ route('user.update',['user'=>$item->username]) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="role" value="1">
                                    <button class="btn btn-sm btn-primary" title="Jadikan Admin">
                                        <i class="bi bi-person-fill-up"></i>
                                    </button>
                                    </form>
                                </div>
                                @else
                                    <div>
                                     <form action="{{ route('user.update',['user'=>$item->username]) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="role" value="3">
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-person-fill-down "></i>
                                    </button>
                                    </form>

                                </div>
                                @endif
                                
                            
                                
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->

    </div>
</div>

@endsection