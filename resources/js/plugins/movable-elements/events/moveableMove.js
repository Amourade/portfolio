import positionReturn from "../utils/positionReturn";

export default function moveableMove(e){
    if(!window.moveableData.hasMoved){
        window.moveableData.hasMoved = true;
        window.moveableData.el.classList.add(window.moveableData.class.moving)
    }

    window.moveableData.mousePos = {x: (e.pageX || e.touches[0].pageX), y: (e.pageY || e.touches[0].pageY)};
	window.moveableData.mouseDiff = {x: window.moveableData.mouseStartDrag.x - window.moveableData.mousePos.x, y: window.moveableData.mouseStartDrag.y - window.moveableData.mousePos.y};

    let positionStyles = positionReturn();
    Object.keys(positionStyles).forEach((key) => {
        window.moveableData.el.style[key] = positionStyles[key];
    })
}