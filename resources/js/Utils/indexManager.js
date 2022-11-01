import { ref } from "vue";

const index = ref(0);

export function useIndexManager(value) {
    index.value = value;

    return index;
}

export function increaseIndex() {
    index.value++;
}
