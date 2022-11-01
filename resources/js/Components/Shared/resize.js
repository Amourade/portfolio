// mouse.js
import { onMounted, ref } from "vue";
import { useEventListener } from "./event";

// by convention, composable function names start with "use"
export function useResize() {
    // state encapsulated and managed by the composable
    const WIDTH = ref(0);
    const HEIGHT = ref(0);

    /*
  // a composable can update its managed state over time.
  function update(event) {
    x.value = event.pageX
    y.value = event.pageY
  }

  // a composable can also hook into its owner component's
  // lifecycle to setup and teardown side effects.
  onMounted(() => window.addEventListener('mousemove', update))
  onUnmounted(() => window.removeEventListener('mousemove', update))
  */
    if (typeof window !== "undefined") {
        WIDTH.value = window.innerWidth;
        HEIGHT.value = window.innerHeight;

        useEventListener(window, "resize", () => {
            WIDTH.value = window.innerWidth;
            HEIGHT.value = window.innerHeight;
        });
    }

    // expose managed state as return value
    return { WIDTH, HEIGHT };
}
