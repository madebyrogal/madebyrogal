# Deploy configuration
set :deploy_config_path, "app/config/deploy.rb"
set :stage_config_path, "app/config/deploy"

# Load DSL and set up stages
require "capistrano/setup"

# Include default deployment tasks
require "capistrano/deploy"
require 'capistrano/composer'

# Load the SCM plugin appropriate to your project:
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git

# Load custom tasks from `lib/capistrano/tasks` if you have any defined
Dir.glob("app/config/deploy/tasks/*.rake").each { |r| import r }
