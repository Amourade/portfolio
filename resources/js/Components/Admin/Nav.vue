<script setup>
import NavLink from "./NavLink.vue";
</script>
<template>
    <ul>
        <li>
            <NavLink href="/">Accueil Publique</NavLink>
        </li>
        <!-- 
    <li>
        <Link href="/admin">Dashboard</Link>
    </li> -->
        <template v-if="$page.props.auth.user">
            <li>
                <NavLink href="/admin/paintings">Peintures</NavLink>
                <NavLink href="/admin/paintings/create"
                    >Nouvelle Peinture</NavLink
                >
            </li>
            <li>
                <NavLink href="/admin/drawings">Dessins</NavLink>
                <NavLink href="/admin/drawings/create">Nouveau Dessin</NavLink>
            </li>
            <li>
                <NavLink href="/admin/projects">Projets</NavLink>
                <NavLink href="/admin/projects/create">Nouveau Projet</NavLink>
            </li>
            <li>
                <NavLink href="/admin/digitals">Digitaux</NavLink>
                <NavLink href="/admin/digitals/create"
                    >Nouveau Digitale</NavLink
                >
            </li>
        </template>
    </ul>
</template>

<style lang="scss" scoped>
ul {
    list-style-type: none;
    padding-left: 0px;

    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    margin-top: 15px;
}

li {
    padding: 10px 20px;
    margin: 10px;

    background: rgba(255, 255, 255, 0.5);
    border: 1px solid white;
    border-radius: 10px;
    box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.4);

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    transition: all 0.5s;

    &:hover {
        box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.4);
    }
}

@media (max-width: 768px) {
    li {
        padding: 5px;
        margin: 5px;
    }
}
</style>
