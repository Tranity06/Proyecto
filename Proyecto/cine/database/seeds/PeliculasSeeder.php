<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Pelicula;

class PeliculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelicula::create([
            'idtmdb' => 299536,
            'titulo' => 'Vengadores: Infinity War',
            'titulo_original' => 'Avengers: Infinity War',
            'estreno' => '2018-04-25',
            'generos' => 'Aventura, Ciencia ficción, Fantasía, Acción',
            'director' => 'Joe Russo, Anthony Russo',
            'actores' => 'Robert Downey Jr., Chris Hemsworth, Mark Ruffalo, Chris Evans, Scarlett Johansson',
            'sinopsis' => 'Vengadores: Infinity War seguirá la lucha de los superhéroes de Marvel contra el mayor villano al que se han enfrentado nunca: Thanos. Su único objetivo será detener a este poderoso antagonista e impedir que se haga con el control de la galaxia. De nuevo veremos al grupo formado por Iron Man, Capitán América, Viuda negra, Ant-Man, Ojo de Halcón, Thor y Hulk, entre otros. En su nueva e impactante aventura, las Gemas del Infinito estarán en juego, unos querrán protegerlas y otros controlarlas, ¿quién ganará?',
            'duracion' => 149,
            'cartel' => 'https://image.tmdb.org/t/p/w342/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=wJbudwIF0cE',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/bOGkgRGdhrBYJSLpXaxhXVstddV.jpg',
            'popularidad' => 604.520984
        ]);

        Pelicula::create([
            'idtmdb' => 284053,
            'titulo' => 'Thor: Ragnarok',
            'titulo_original' => 'Thor: Ragnarok',
            'estreno' => '2017-10-25',
            'generos' => 'Acción, Aventura, Fantasía',
            'director' => 'Taika Waititi',
            'actores' => 'Chris Hemsworth, Tom Hiddleston, Cate Blanchett, Mark Ruffalo, Tessa Thompson',
            'sinopsis' => 'Thor está preso al otro lado del universo sin su poderoso martillo y se enfrenta a una carrera contra el tiempo. Su objetivo es volver a Asgard y parar el Ragnarok porque significaría la destrucción de su planeta natal y el fin de la civilización Asgardiana a manos de una todopoderosa y nueva amenaza, la implacable Hela. Pero, primero deberá sobrevivir a una competición letal de gladiadores que lo enfrentará a su aliado y compañero en los Vengadores, ¡el Increíble Hulk!',
            'duracion' => 130,
            'cartel' => 'https://image.tmdb.org/t/p/w342/s7hV8HFh7w2EZ4GK5EiltRVvWJA.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=rwPvpkfozCE',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/kaIfm5ryEOwYg8mLbq8HkPuM1Fo.jpg',
            'popularidad' => 174.148284
        ]);

        Pelicula::create([
            'idtmdb' => 353486,
            'titulo' => 'Jumanji: Bienvenidos a la jungla',
            'titulo_original' => 'Jumanji: Welcome to the Jungle',
            'estreno' => '2017-12-09',
            'generos' => 'Acción, Aventura, Comedia, Familia',
            'director' => 'Jake Kasdan',
            'actores' => 'Dwayne Johnson, Jack Black, Kevin Hart, Karen Gillan, Nick Jonas',
            'sinopsis' => 'Cuatro adolescentes son absorbidos por un videojuego, en el que se convierten en avatares de personajes arquetípicos. Allí vivirán múltiples aventuras, al tiempo que buscan cómo salir de allí para volver a su mundo.',
            'duracion' => 119,
            'cartel' => 'https://image.tmdb.org/t/p/w342/thmLO2GWf6NcuNOoYtv2gOomE4x.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=leIrosWRbYQ',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/rz3TAyd5kmiJmozp3GUbYeB5Kep.jpg',
            'popularidad' => 54.184919
        ]);

        Pelicula::create([
            'idtmdb' => 258230,
            'titulo' => 'Un monstruo viene a verme',
            'titulo_original' => 'A Monster Calls',
            'estreno' => '2016-10-07',
            'generos' => 'Drama, Fantasía',
            'director' => 'Juan Antonio Bayona',
            'actores' => 'Lewis MacDougall, Sigourney Weaver, Felicity Jones, Toby Kebbell, Liam Neeson',
            'sinopsis' => 'Connor es un joven de 12 años que, tras la separación de sus padres, se convierte en el hombre de la casa y el encargado de llevar las riendas del hogar. Con su joven madre enferma de cáncer, el pequeño intentará superar todos sus miedos y fobias con la ayuda de un monstruo. Fantasía, cuentos de hadas e historias imaginarias del pequeño se verán las caras no sólo con la realidad, sino con su fría y calculadora abuela... Con este nuevo trabajo J.A. Bayona cerrará una trilogía sobre las relaciones madre-hijo, que inició con "El orfanato" y continuó con "Lo imposible".',
            'duracion' => 108,
            'cartel' => 'https://image.tmdb.org/t/p/w342/mMlZ9Sgznja3vCaOOu2yfXlvCZH.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=1-fubC9JN50',
            'slider_image' => 'https://image.tmdb.org/t/p/w500/xVW8REyVqKwxAtUYY07UGlZH43L.jpg',
            'popularidad' => 10.935435
        ]);

        Pelicula::create([
            'idtmdb' => 429351,
            'titulo' => '12 valientes',
            'titulo_original' => '12 Strong',
            'estreno' => '2018-01-18',
            'generos' => 'Guerra, Drama, Historia',
            'director' => 'Nicolai Fuglsig',
            'actores' => 'Chris Hemsworth, Michael Shannon, Michael Peña, Trevante Rhodes, Navid Negahban',
            'sinopsis' => 'Un equipo de fuerzas especiales de la CIA es enviado a Afganistán tras los atentados del 11-S para desmantelar a los talibanes. Tras conseguir introducirse en secreto en el país, deben perseguir cabalgando a sus enemigos por el montañoso terreno e intentar capturar a Mazar-i-Sharif. Pero pronto se ven sobrepasados en número y envueltos en una peligrosa situación, con sus vidas corriendo un grave peligro.',
            'duracion' => 130,
            'cartel' => 'https://image.tmdb.org/t/p/w342/8YcjGJtW4AEHyNH8yrs8FAaPBM.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=8I3piz5dFzA',
            'slider_image' => 'https://image.tmdb.org/t/p/w500/wacEk5YSNE41QeKseilyytksXmv.jpg',
            'popularidad' => 28.814109
        ]);

        Pelicula::create([
            'idtmdb' => 333339,
            'titulo' => 'Ready Player One',
            'titulo_original' => 'Ready Player One',
            'estreno' => '2018-03-28',
            'generos' => 'Aventura, Ciencia ficción, Acción',
            'director' => 'Steven Spielberg',
            'actores' => 'Tye Sheridan, Olivia Cooke, Lena Waithe, Ben Mendelsohn, T.J. Miller',
            'sinopsis' => 'Año 2044. Wade Watts es un adolescente al que le gusta evadirse del cada vez más sombrío mundo real a través de una popular utopía virtual a escala global llamada Oasis, hasta que su excéntrico y multimillonario creador muere. Antes de morir, ofrece su fortuna como premio a una elaborada búsqueda del tesoro a través de los rincones más inhóspitos de su creación. Será el punto de partida para que Wade se enfrente a jugadores, poderosos enemigos corporativos y otros competidores despiadados dispuestos a hacer lo que sea, tanto dentro de Oasis como del mundo real, para hacerse con el premio.',
            'duracion' => 140,
            'cartel' => 'https://image.tmdb.org/t/p/w342/pU1ULUq8D3iRxl1fdX2lZIzdHuI.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=J0ZKannF6l4',
            'slider_image' => 'https://image.tmdb.org/t/p/w500/q7fXcrDPJcf6t3rzutaNwTzuKP1.jpg',
            'popularidad' => 64.510558
        ]);

        Pelicula::create([
            'idtmdb' => 401981,
            'titulo' => 'Gorrión rojo',
            'titulo_original' => 'Red Sparrow',
            'estreno' => '2018-03-01',
            'generos' => 'Misterio, Suspense',
            'director' => 'Francis Lawrence',
            'actores' => 'Jennifer Lawrence, Joel Edgerton, Matthias Schoenaerts, Charlotte Rampling, Jeremy Irons',
            'sinopsis' => 'Dominika Egorova (Jennifer Lawrence) es reclutada contra su voluntad para ser un “gorrión”, una seductora adiestrada del servicio de seguridad ruso. Dominika aprende a utilizar su cuerpo como arma, pero lucha por conservar su sentido de la identidad durante el deshumanizador proceso de entrenamiento. Hallando su fuerza en un sistema injusto, se revela como uno de los activos más sólidos del programa. Su primer objetivo es Nate Nash (Joel Edgerton), un funcionario de la CIA que dirige la infiltración más confidencial de la agencia en la inteligencia rusa. Los dos jóvenes agentes caen en una espiral de atracción y engaño que amenaza sus carreras, sus lealtades y la seguridad de sus respectivos países.',
            'duracion' => 139,
            'cartel' => 'https://image.tmdb.org/t/p/w342/wt6wL8ZnzqSsg2xUBRdfJn3ELVa.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=271Ap7cCZ4E',
            'slider_image' => 'https://image.tmdb.org/t/p/w500/uBw0QSBWamSWXWl5ttwhxq4h09s.jpg',
            'popularidad' => 30.097552
        ]);

        Pelicula::create([
            'idtmdb' => 348350,
            'titulo' => 'Han Solo: Una Historia de Star Wars',
            'titulo_original' => 'Solo: A Star Wars Story',
            'estreno' => '2018-05-23',
            'generos' => 'Acción, Aventura, Ciencia ficción',
            'director' => 'Ron Howard',
            'actores' => 'Alden Ehrenreich, Woody Harrelson, Emilia Clarke, Donald Glover, Thandie Newton',
            'sinopsis' => 'Precuela de la saga Star Wars, en la que se conocerán los primeros pasos que dio el personaje de Han Solo, desde joven hasta convertirse en el antihéroe que vimos en "Una nueva esperanza", antes de que se encontrase con Luke y Obi-Wan en la cantina de Mos Eisley.',
            'duracion' => 143,
            'cartel' => 'https://image.tmdb.org/t/p/w342/4oD6VEccFkorEBTEDXtpLAaz0Rl.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=lFmNk0nd5es',
            'slider_image' => 'https://image.tmdb.org/t/p/w500/96B1qMN9RxrAFu6uikwFhQ6N6J9.jpg',
            'popularidad' => 31.896665
        ]);
    }
}
