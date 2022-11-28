/* global __dirname, exports */
exports.path = require('path')
exports.APP_DIR = exports.path.resolve(__dirname, 'javascript')

const adminScripts = {
  Dashboard: exports.APP_DIR + '/Admin/Dashboard/index.tsx',

}

const userScripts = {
  WelcomeHeader: exports.APP_DIR + '/User/WelcomeHeader/index.tsx',
  
}

exports.entry = {...adminScripts, ...userScripts}
