set :domain, "188.40.80.195:59184"
set :app_user, "rogal81"
set :web_user, "rogal81"
set :tmp_dir, '/home/rogal81/tmp'
set :deploy_to, "/home/rogal81/domains/madebyrogal.com"
server fetch(:domain), user: fetch(:app_user), roles: [:app, :web]
