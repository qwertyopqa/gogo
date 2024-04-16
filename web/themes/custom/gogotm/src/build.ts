import type { BunPlugin } from 'bun';

const entry = './sass/main.scss';
const out = '../css/main.css';

const style: BunPlugin = {
    name: 'Sass Loader',
    async setup(build: any) {
        // implementation
        console.log('Running SASS Plugin...');

        const sass = await import('sass');

        // when a .scss file is imported...
        build.onLoad({ filter: /\.scss$/ }, ({ path }: {path: string}) => {
            // read and compile it with the sass compiler
            const contents = sass.compile(path);

            globalThis.Bun.write(out, contents.css);

            // and return the compiled source code as "css"
            return {};
        });
    },
};

// start build main.css
globalThis.Bun.build({
    entrypoints: [out],
    plugins: [style]
});
