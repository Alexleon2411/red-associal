@extends('layouts.app')


@section('titulo')
   Iniciar  en <span class="text-bold text-red-800">Red-Associal</span>
@endsection
@section('contenido')
    <div class="md:flex md: justify-center md:gap-4 md:items-center">
        <div class="md:w-6/12">
            <img src="{{asset('img/login.jpg')}}" alt="" class="">
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form method="POST"  action="{{route('login')}}" novalidate>
                @csrf
                @if(session('mensaje'))

                    <p class="text-bold text-red-600">{{session('mensaje')}} </p>
                @endif
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

                <div class="my-5">
                    <input type="checkbox" name="remember" >  <label class=" uppercase text-gray-500 text-sm">Manterner sesion iniciada</label>
                </div>
                <input type="submit" value="Iniciar Sesion" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
