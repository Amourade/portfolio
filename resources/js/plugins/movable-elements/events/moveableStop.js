import eventListener from "../utils/eventListener";
import moveableMove from "./moveableMove";
import moveableStart from "./moveableMove";
import moveableStop from "./moveableStop";
import { Inertia } from "@inertiajs/inertia";

export default function () {
    window.moveableData.el.classList.remove(window.moveableData.class.moving);

    eventListener(document, ["mousemove", "touchmove"], moveableMove, "remove");
    eventListener(document, ["mouseup", "touchend"], moveableStop, "remove");

    const el = window.moveableData.el;

    window.moveableData.el = undefined;

    if (
        !window.moveableData.hasMoved &&
        el.getAttribute("data-moveable-close") === "true"
    ) {
        el.getElementsByTagName("a")[0].click();
        return;
    }

    if (!window.moveableData.hasMoved && window.moveableData.targetLink) {
        Inertia.visit(window.moveableData.targetLink);
        //window.moveableData.el.click();
        //window.location.href = window.moveableData.targetLink;
    }
}
