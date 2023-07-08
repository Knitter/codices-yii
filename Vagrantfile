require 'yaml'
require 'fileutils'

# Prepare required plugins
#
required_plugins_installed = false
required_plugins = %w( vagrant-hostmanager vagrant-vbguest )
required_plugins.each do |plugin|
  unless Vagrant.has_plugin? plugin
    system "vagrant plugin install #{plugin}"
    required_plugins_installed = true
  end
end

if required_plugins_installed
  # Get CLI command[s] and call again
  system 'vagrant' + ARGV.to_s.gsub(/\[\"|\", \"|\"\]/, ' ')
  exit
end

# Copy example config if local doesn't exist, load settings if file exists
#
domains = {
  main: '.test'
  # backend:  '<other domain name>.test'
}

config = {
  local: './env/config/vagrant-local.yml',
  example: './env/config/vagrant-local.example.yml'
}

FileUtils.cp config[:example], config[:local] unless File.exist?(config[:local])
options = YAML.load_file config[:local]

# check github token
if options['github_token'].nil?
  puts "You must place REAL GitHub token into configuration:\config-local.yml"
  exit
end

# Vagrant Settings
Vagrant.configure(2) do |config|
  config.vm.box = 'debian/bullseye64'
  config.vm.box_check_update = options['box_check_update']

  config.vm.provider 'virtualbox' do |vb|
    vb.cpus = options['cpus']
    vb.memory = options['memory']
    vb.name = options['machine_name']
	# vb.customize ["modifyvm", :id, "--natdnsproxy1", "off"]
  end

  config.vm.define options['machine_name']
  config.vm.hostname = options['machine_name']
  config.vm.network 'private_network', ip: options['ip']

  # sync: folder '<folder>' (host machine) -> '<folder>' (guest machine)
  config.vm.synced_folder './', '/app', owner: 'vagrant', group: 'vagrant'
  config.vm.synced_folder './', '/rsrc', type: 'rsync'

  config.vm.provider 'virtualbox' do |vb|
    vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate//app", "1"]
  end
  
  # disable folder '/vagrant' (guest machine)
  config.vm.synced_folder '.', '/vagrant', disabled: true

  # hosts settings (host machine)
  config.vm.provision :hostmanager
  config.hostmanager.enabled            = true
  config.hostmanager.manage_host        = true
  config.hostmanager.ignore_private_ip  = false
  config.hostmanager.include_offline    = true
  config.hostmanager.aliases            = domains.values

  # provisioners
  config.vm.provision 'shell', path: './env/provision/once-as-root.sh', args: [options['timezone'], options['ip']]
  config.vm.provision 'shell', path: './env/provision/once-as-vagrant.sh', args: [options['github_token']], privileged: false
  config.vm.provision 'shell', path: './env/provision/always-as-root.sh', run: 'always'

  # post-install message (vagrant console)
  config.vm.post_up_message = "Ready @: http://#{domains[:main]}"
end
