// Shorthand for muliple events with the same function
export default function (element, types, func, state = 'add') {
  types.forEach((type) => {
    element[`${state}EventListener`](type, func);
  });
}
