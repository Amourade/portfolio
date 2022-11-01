// mouse.js
import { ref, onMounted } from "vue";
import { useEventListener } from "./event";

// by convention, composable function names start with "use"
export function useMouse() {
    // state encapsulated and managed by the composable
    const x = ref(0);
    const y = ref(0);

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
        useEventListener(window, "mousemove", (event) => {
            x.value = event.pageX;
            y.value = event.pageY;
        });
    }

    // expose managed state as return value
    return { x, y };
}
