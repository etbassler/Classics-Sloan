/**
 * Check if currently within a Bootstrap breakpoint
 * @param {string} alias Bootstrap breakpoint ['xs', 'sm', 'md', 'lg', 'xl']
 * @return {boolean}
 */

const isBreakpoint = alias => $(`.is-visible-${alias}`).is(':visible');

export default isBreakpoint;
