import eventListener from "../utils/eventListener";
import moveableStart from "./moveableStart";
import moveableStop from "./moveableStop";

export default function (el, binding) {
    el.classList.add(window.moveableData.class.moveable)

    eventListener(el,['mousedown', 'touchstart'], (e)=> moveableStart(el, e));
}