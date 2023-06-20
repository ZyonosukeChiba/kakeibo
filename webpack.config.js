
const path=require('path')

module.exports={

    mode:'production',
    entry:path.resolve(__dirname, './public/assets/js/src/index.js'),
    module: {
        rules: [
          {
            test: /\.(?:js|jsx|cjs)$/,
            exclude: /node_modules/,
            use: {
              loader: 'babel-loader', //バベル適用
              options: {
                presets: [
                  ['@babel/preset-env', { targets: "defaults" }]
                ]
              }
            }
          }
        ]
      },
    output : {
        path: path.resolve(__dirname,"./public/assets/js/src"),
        filename:'bundle.js',
        
},
    resolve: {
        extensions:[".js",".jsx"],

    },
    devServer:{
        directory:path.resolve(__dirname,"./public/assets/js/src"),
        port:3030,
    }


};
