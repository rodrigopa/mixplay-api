import AdminApp from '../views/AdminApp'
import LoginComponent from '../views/LoginComponent'
import NotFound from "../views/NotFound";

// genres
import Genre from "../views/genre/Genre";
import GenreList from "../views/genre/List";
import GenreForm from "../views/genre/Form";

export default [
    { path: '/', component: AdminApp,
        children: [
            { path: '/genre', component: Genre,
                children: [
                    { path: '/', name: 'genre.index', component: GenreList, props: (route) => ({ page: route.query.page }) },
                    { path: 'create', name: 'genre.create', component: GenreForm },
                    { path: ':id', name: 'genre.edit', component: GenreForm, props: () => ({ update: true }) },
                ]
            },

            // Not found
            { path: '*', component: NotFound }
        ]
    }
]
