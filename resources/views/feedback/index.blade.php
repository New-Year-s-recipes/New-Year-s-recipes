@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="title">Обратная связь</h1>
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ФИО</th>
                    <th>Email</th>
                    <th>Комментарий</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($feedbacks as $feedback)
                    <tr>
                        <td>{{ $feedback->id }}</td>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->email }}</td>
                        <td>{{ $feedback->comments }}</td>
                        <td>{{ $feedback->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row">Нет данных для отображения</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection