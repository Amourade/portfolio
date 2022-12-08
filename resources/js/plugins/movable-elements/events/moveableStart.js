import moveableMove from "./moveableMove";
import moveableStop from "./moveableStop";
import eventListener from "../utils/eventListener";

export default function moveableStart(el, e) {
    //If the event target is a link we store the target for later use
    //console.log(e);
    e.preventDefault();
    /* e.target.tagName === "A"
        ? (window.moveableData.targetLink = e.target.href)
        : (window.moveableData.targetLink = null); */
    e.target.tagName === "A"
        ? (window.moveableData.targetLink = e.target)
        : (window.moveableData.targetLink = null);

    el.getElementsByClassName("destination").length > 0
        ? (window.moveableData.destination =
              el.getElementsByClassName("destination")[0].href)
        : (window.moveableData.destination = null);
    //Initiate current moving object
    window.moveableData.el = el;
    window.moveableData.hasMoved = false;
    window.moveableData.mouseDiff = { x: 0, y: 0 };

    window.moveableData.mouseStartDrag = {
        x: e.pageX || e.touches[0].pageX,
        y: e.pageY || e.touches[0].pageY,
    };
    window.moveableData.draggedStartPos = {
        x: window.moveableData.el.getBoundingClientRect().left,
        y: window.moveableData.el.getBoundingClientRect().top,
    };

    eventListener(
        el,
        ["mousedown", "touchstart"],
        (e) => moveableStart(el, e),
        "remove"
    );
    eventListener(document, ["mousemove", "touchmove"], moveableMove);
    eventListener(document, ["mouseup", "touchend"], moveableStop);
}
