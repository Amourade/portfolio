<template>
<div class="dimensions">
    <h2>Dimensions (Pouces)</h2>
    <div class="fields">
        <slot />
    </div>
</div>
</template>

<style lang="scss" scoped>

h2{
    margin-bottom: 10px;
    font-size: 1.8em;
}
.dimensions{
    margin-top: 15px;
}

.fields{
    display: grid;
    grid-template-columns: 30% 30% 30%;
    column-gap: 4.5%;
}

</style>