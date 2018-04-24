@extends('layouts.app')

@section('content')

    <h1>タスク一覧</h1>

    @if (count($tasks) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ステータス</th>
                    <th>タスク</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        @if (\Auth::check()) 
                            @if (\Auth::user()->id == $task->user_id)
                                <td>{!! link_to_route('tasks.show', $task->id, ['id' => $task->id]) !!}</td>
                            @else
                                <td>{!! link_to_route('tasks.index', $task->id, ['id' => $task->id]) !!}</td>
                            @endif
                        @else
                            <td>{!! link_to_route('tasks.index', $task->id, ['id' => $task->id]) !!}</td>
                        @endif
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->content }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif



    {!! link_to_route('tasks.create', '新規タスクの投稿', null, ['class' => 'btn btn-primary']) !!}

@endsection