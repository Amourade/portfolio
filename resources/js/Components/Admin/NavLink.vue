<template>
    <Link><slot /></Link>
</template>
<style lang="scss" scoped>
a,
button {
    text-decoration: none;
    text-align: center;
    cursor: pointer;
    font-family: "Caveat", cursive;
    font-size: 1.4em;

    padding: 2px 10px;
    background: rgba(183, 129, 195, 0.3);
    border: 1px solid rgb(183, 129, 195);
    border-radius: 15px;

    box-shadow: 2px 2px 2px 0px rgba(0, 0, 0, 0.4);

    color: #050545;

    transition: all 0.5s;

    &:hover {
        background: rgba(183, 129, 195, 0.6);
        color: black;
        box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3);
    }

    &:not(:first-child) {
        margin-top: 10px;
    }
}

@media (max-width: 768px) {
    a,
    button {
        padding: 2px 5px;
    }
}
</style>
