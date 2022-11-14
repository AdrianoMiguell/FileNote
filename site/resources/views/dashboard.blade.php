@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2 bg-light rounded shadow-sm border border-2 p-3 my-4 col-2">
            <!-- Button trigger modal - Criar anotação -->
            <button type="button" class="btn btn-warning d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createNote">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-plus-circle mx-1" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
                Create
            </button>
            <!-- Modal - Criar anotação -->
            <div class="modal fade" id="createNote" tabindex="-1" aria-labelledby="createNoteLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createNoteLabel">Criar Anotação</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('create.note') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <label>Título:</label>
                                <input class="form-control" type="text" name="title">
                                <label>Conteúdo:</label>
                                <textarea class="form-control" name="content" cols="30" rows="10"></textarea>
                                <label>Cor:</label>
                                <input class="form-control" type="color" name="color">
                                <label>Arquivo:</label>
                                <input class="form-control" type="file" name="image">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-warning">Criar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex flex-wrap justify-content-around gap-2">
        @forelse ($notes as $key => $note)
            <div class="card border border-2 shadow p-3 m-2 w-25" style="background-color: {{ $note->color }}">
                <div class="card-header bg-white text-dark text-center m-1"> {{ $note->title }}</div>
                <div class="card-body bg-white text-dark m-1"> {{ $note->content }} </div>
                <div class="card-body bg-white text-dark m-1"> {{ $note->image }} </div>
                {{-- Editar e Deletar --}}
                <div class="d-flex justify-content-around m-2">
                    {{-- Editar --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar_anotacao" data-bs-note="{{ json_encode($note) }}">
                        Editar
                    </button>
                    {{-- Deletar --}}
                    <form action="{{route('users.delete', $note->id)}} " method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Deletar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="alert alert-danger">
                Nenhuma anotação cadastrada!
            </div>
    </div>
    @endforelse

    <!-- Modal -->
    <div class="modal fade" id="editar_anotacao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Editar </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.note') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="modal-body">
                            <label>Título:</label>
                            <input class="form-control" type="text" name="title" id="title">
                            <label>Conteúdo:</label>
                            <textarea class="form-control" name="content" cols="30" rows="10" id="content"></textarea>
                            <label>Cor:</label>
                            <input class="form-control" type="color" name="color" id="color">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            const exampleModal = document.getElementById('editar_anotacao')
            exampleModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const recipient = button.getAttribute('data-bs-note')
                const note = JSON.parse(recipient);
                document.getElementById('id').value = note.id;
                document.getElementById('title').value = note.title;
                document.getElementById('content').value = note.content;
                document.getElementById('color').value = note.color;
            })
        </script>
    @endsection
