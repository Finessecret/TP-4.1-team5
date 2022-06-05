<template>
    <nav class="navbar navbar-expand-xl navbar-light bg-light p-4">

        <router-link class="navbar-brand" to="/">
            <img src="logo.jpg" alt="Главная" height="60" />
        </router-link>

        <router-link class="navbar-brand" to="/about">
            О нас
        </router-link>

        <div class="collapse navbar-collapse justify-content-end pe-5">
            <form class="form-inline my-2 my-lg-0">
                <router-link class="nav-link" to="/login">
                    <button class="btn btn-primary" type="button">
                        Вход
                    </button>
                </router-link>
            </form>
        </div>
    </nav>
</template>

