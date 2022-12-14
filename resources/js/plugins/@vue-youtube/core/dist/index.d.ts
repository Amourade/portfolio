import type { ShallowRef } from 'vue-demi';
import type { PlaybackQualityChangeCallback, PlaybackRateChangeCallback, PlayerStateChangeCallback, APIChangeCallback, MaybeElementRef, ErrorCallback, ReadyCallback, PlayerVars, MaybeRef, Player } from '@vue-youtube/shared';
export interface Options {
    height?: number | string;
    width?: number | string;
    playerVars?: PlayerVars;
    cookie?: boolean;
}
/**
 * Initialize a reactive YouTube player
 *
 * @see https://vue-youtube.github.io/docs/usage/composable.html
 * @param newVideoId Video ID as a string or a ref
 * @param element Template ref to the target element
 * @param options Player options
 */
export declare const usePlayer: (newVideoId: MaybeRef<string>, element: MaybeElementRef, options?: Options) => {
    instance: ShallowRef<Player | undefined>;
    togglePlay: () => void;
    toggleMute: () => void;
    toggleLoop: () => void;
    toggleShuffle: () => void;
    onPlaybackQualityChange: (...cb: Array<PlaybackQualityChangeCallback>) => void;
    onPlaybackRateChange: (...cb: Array<PlaybackRateChangeCallback>) => void;
    onStateChange: (...cb: Array<PlayerStateChangeCallback>) => void;
    onApiChange: (...cb: Array<APIChangeCallback>) => void;
    onError: (...cb: Array<ErrorCallback>) => void;
    onReady: (...cb: Array<ReadyCallback>) => void;
};
export declare type UsePlayerReturn = ReturnType<typeof usePlayer>;
export * from '@/plugins/@vue-youtube/shared';
export * from './manager';
