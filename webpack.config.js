
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

          },
          {
            test: /\.css$/,
            use: ['style-loader', 'css-loader']
          }
        ]
      },
    output : {
        path: path.resolve(__dirname,"./public/assets/js/src"),
        filename:'bundle2.js',
        
},
    resolve: {
        extensions:[".js",".jsx"],

    },
  
  



};
