import eventListener from "../utils/eventListener"
import moveableMove from "./moveableMove"

export default function(){
    if(!window.moveableData.hasMoved && window.moveableData.targetLink){
        //window.location.href = window.moveableData.targetLink;
        window.moveableData.el.click();
    }

    window.moveableData.el.classList.remove(window.moveableData.class.moving)

    eventListener(document, ['mousemove', 'touchmove'], moveableMove, 'remove')
}