/**
 * Shared Alpine.js context type for component factories.
 *
 * Use as `this: AlpineContext` in factory return-object methods, or extend
 * with extra refs/wire shape via the generic parameters when useful.
 */
export interface AlpineContext<TWire = any, TRefs extends Record<string, HTMLElement> = Record<string, HTMLElement>> {
    $el: HTMLElement;
    $refs: TRefs;
    $wire: TWire;
    $watch: <T>(key: string, callback: (value: T, old: T) => void) => void;
    $nextTick: (callback: () => void) => void;
    $dispatch: (event: string, detail?: unknown) => void;
    $store: Record<string, any>;
}

export type AlpineComponent<TState extends object, TWire = any> =
    TState & ThisType<TState & AlpineContext<TWire>>;

export type AlpineFactory<TState extends object, TArgs extends unknown[] = [], TWire = any> =
    (...args: TArgs) => AlpineComponent<TState, TWire>;
