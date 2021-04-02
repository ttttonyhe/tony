const path = require('path');
module.exports = {
    mode: 'production',
    entry: {
        index: './src/index.js',
        single: './src/single.js',
        tag: './src/tag.js',
        archive: './src/archive.js',
        posts: './src/posts.js',
        page: './src/page.js',
    },
    output: {
        filename: '[name].js',
        path: path.resolve('dist/js/')
    }
}