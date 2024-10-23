<div class="container">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
        * {
            box-sizing: border-box;
        }
        .container {
            text-align: center;
        }
        .container-imagem {
            position: absolute;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 0;
            width: 85%;
            height: auto;
        }

        .container-imagem img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0 0 15px 15px;
        }
        .container-users{
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 120px;
        }
    </style>
    <div class="container-imagem">
        <img src="{{ asset('storage/imagens/banner.jpeg') }}" alt="Example Image">

    </div>

    <div class="row container-users">
        @foreach($users as $user)
            <div class="col-8 col-sm-6 col-md-4">
                <div class="card h-100" style="margin-top: 10px">
                    <img src="{{ asset('storage/imagens/naruto.jpeg') }}" class="card-img-top" alt="foto user">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($selectedUser)
        <div class="alert alert-info mt-4">
            Utilizador selecionado: {{ $users->find($selectedUser)->name }}
        </div>
    @endif

</div>
