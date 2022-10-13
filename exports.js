/* global __dirname, exports */
exports.path = require('path')
exports.APP_DIR = exports.path.resolve(__dirname, 'javascript')

const adminScripts = {

}

const userScripts = {
  WelcomeHeader: exports.APP_DIR + '/User/WelcomeHeader/index.tsx',
  
}

const participantScripts = {
  
}

exports.entry = {...adminScripts, ...userScripts, ...participantScripts}
