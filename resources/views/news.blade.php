<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Últimas Noticias
            </h2>
            <Form method="GET" action="{{ route('news.update') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-800 text-white shadow hover:bg-gray-600 py-2 px-4 rounded font-semibold">Actualizar
                    noticias</button>
            </Form>
        </div>
    </x-slot>

    <div class="py-12">
        @if (!empty($news))
            @foreach ($news as $news_data)
                <div class="flex w-full mb-2">
                    <div class="w-1/4">
                        @if ($news_data['image'])
                            <img src={{ $news_data['image'] }} alt={{ $news_data['source'] }}>
                        @else
                            <img src="https://i.pinimg.com/originals/ae/8a/c2/ae8ac2fa217d23aadcc913989fcc34a2.png"
                                alt={{ $news_data['source'] }}>
                        @endif
                    </div>
                    <div class="w-3/4">
                        <h2 class="text-2xl">{{$news_data['title']}}</h2>
                        <h5 class="text-xs mt-2">Categoría: {{$news_data['category']}}</h5>
                        <h6 class="text-xs">Fuente: {{$news_data['source']}}</h6>
                        <h6 class="text-xs">Fecha de publicación: {{$news_data['published_at']}}</h6>
                        <h6 class="text-xs">Autor: {{$news_data['author']}}</h6>
                        <p class="mt-2">{{$news_data['description']}}</p>
                        <a class="text-blue-600 mt-2" href={{$news_data['url']}}>Link</a>
                    </div>
                </div>
            @endforeach
        @else
            <h4>Cargando...</h4>
        @endif
    </div>
</x-app-layout>
