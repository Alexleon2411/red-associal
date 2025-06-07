@extends('layouts.app')


@section('titulo')
   Register en Red-Associal
@endsection
@section('contenido')
    <div class="md:flex md: justify-center md:gap-4 md:items-center">
        <div class="md:w-6/12">
            <img src="{{asset('img/registerimg.jpg')}}" alt="" class="">
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form action="{{route('register')}}" method="POST">
                @csrf
                <div  class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Nombre</label>
                    <input type="text" id="name" name="name" placeholder="Tu nombre" class="border p-3 w-full rounded-lg @error('name') border-red-500
                    @enderror" value="{{old('name')}}">
                    @error('name')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                <div  class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de usuario</label>
                    <input type="text" id="username" name="username" placeholder="Tu nombre de usuario" class="border p-3 w-full rounded-lg @error('username') border-red-500
                    @enderror" value="{{old('username')}}">
                    @error('username')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                <div  class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="text" id="email" name="email" placeholder="Tu email" class="border p-3 w-full rounded-lg @error('email') border-red-500
                    @enderror" value="{{old('email')}}">
                    @error('email')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                <div  class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password</label>
                    <input type="text" id="password" name="password" placeholder="Password de registro" class="border p-3 w-full rounded-lg @error('password') border-red-500
                    @enderror">
                    @error('password')
                        <p class="text-bold text-red-600">{{$message}} </p>
                    @enderror
                </div>
                <div  class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">Confirm password</label>
                    <input type="text" id="password_confirmation" name="password_confirmation" placeholder="Repetir password" class="border p-3 w-full rounded-lg">
                </div>
                <input type="submit" value="crear ceunta" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
