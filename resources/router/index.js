import {createRouter, createWebHistory} from "vue-router";
import RegisterView from "../views/User/RegisterView.vue";
import LoginView from "../views/User/LoginView.vue";

import CreateAuthorView from "../views/Authors/CreateView.vue";
import UpdateAuthorView from "../views/Authors/UpdateView.vue";
import ListAuthorView from "../views/Authors/ListView.vue";

import CreateSubjectView from "../views/Subjects/CreateView.vue";
import UpdateSubjectView from "../views/Subjects/UpdateView.vue";
import ListSubjectView from "../views/Subjects/ListView.vue";

import CreateBookView from "../views/Books/CreateView.vue";
import UpdateBookView from "../views/Books/UpdateView.vue";
import ListBookView from "../views/Books/ListView.vue";

import reportView from "../views/Reports/ListView.vue";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: LoginView,
        },
        {
            path: "/register",
            name: "register",
            component: RegisterView,
            meta: {guest: true},
        },
        // Authors
        {
            path: "/authors/list",
            name: "listAuthor",
            component: ListAuthorView,
        },
        {
            path: "/authors/create",
            name: "createAuthor",
            component: CreateAuthorView,
            meta: {auth: true},
        },
        {
            path: "/authors/:id",
            name: "updateAuthor",
            component: UpdateAuthorView,
        },
        // Subjects
        {
            path: "/subjects/list",
            name: "listSubject",
            component: ListSubjectView,
        },
        {
            path: "/subjects/create",
            name: "createSubject",
            component: CreateSubjectView,
            meta: {auth: true},
        },
        {
            path: "/subjects/:id",
            name: "updateSubject",
            component: UpdateSubjectView,
        },
        // Books
        {
            path: "/books/list",
            name: "listBook",
            component: ListBookView,
        },
        {
            path: "/books/create",
            name: "createBook",
            component: CreateBookView,
            meta: {auth: true},
        },
        {
            path: "/books/:id",
            name: "updateBook",
            component: UpdateBookView,
        },
        // reports
        {
            path: "/reports",
            name: "reports",
            component: reportView,
        },
    ],
});

router.beforeEach(async () => {
    const token = localStorage.getItem("token")
    if (token === false) {
        return {name: "home"};
    }
});

export default router;
