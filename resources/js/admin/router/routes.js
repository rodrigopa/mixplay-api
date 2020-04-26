import AdminApp from '../views/AdminApp'
import LoginComponent from '../views/LoginComponent'
import NotFound from "../views/NotFound";

// genres
import Genre from "../views/genre/Genre";
import GenreList from "../views/genre/List";

export default [
    { path: '/', component: AdminApp,
        children: [
            { path: '/genre', component: Genre,
                children: [
                    { path: '/', name: 'genre.index', component: GenreList },
                ]
            },

            // Not found
            { path: '*', component: NotFound }
        ]
    }
]
