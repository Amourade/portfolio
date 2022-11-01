export default function positionReturn(){
    return {
        left: window.moveableData.draggedStartPos.x - window.moveableData.mouseDiff.x + 'px',
        top: window.moveableData.draggedStartPos.y - window.moveableData.mouseDiff.y + 'px',
        transform: 'translate(0%,0%)'
    }
}