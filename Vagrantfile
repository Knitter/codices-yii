require 'yaml'
require 'fileutils'

required_plugins = %w( vagrant-hostmanager vagrant-vbguest )
required_plugins.each do |plugin|
    exec "vagrant plugin install #{plugin}" unless Vagrant.has_plugin? plugin
end

# read config
options = YAML.load_file 'config.yml'

# check github token
if options['github_token'].nil?
  puts "You must place REAL GitHub token into configuration:\config-local.yml"
  exit
end

defaultSettings = {
  timezone: "Europe/London",
  box_check_update: true,
  machine_name: "codices",
  ip: "192.168.83.10",
  cpus: 1,
  memory: 1024,
  box: 'debian/bookworm64'
}

options.transform_keys!(&:to_sym) rescue {}
settings = defaultSettings.merge(options)
#puts "#{settings}"

# vagrant configurate
Vagrant.configure(2) do |config|
  config.vm.box = settings[:box]

  config.vm.box_check_update = settings[:box_check_update]
  config.vm.provider 'virtualbox' do |vb|
    vb.cpus = settings[:cpus]
    vb.memory = settings[:memory]
    vb.name = settings[:machine_name]
	vb.customize ["modifyvm", :id, "--natdnsproxy1", "off"]
  end

  config.vm.define settings[:machine_name]
  config.vm.hostname = settings[:machine_name]
  config.vm.network 'private_network', ip: settings[:ip]

  # sync: folder 'xyz' (host machine) -> folder '/app' (guest machine)
  config.vm.synced_folder './', '/project', owner: 'vagrant', group: 'vagrant'
  config.vm.synced_folder './codices-app', '/codices', owner: 'vagrant', group: 'vagrant'
  # config.vm.synced_folder './src/', '/rsrc', type: 'rsync'

  config.vm.provider 'virtualbox' do |vb|
    vb.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate//app", "1"]
  end
  
  # disable folder '/provision' (guest machine)
  config.vm.synced_folder '.', '/env/vagrant-provision', disabled: true

  # hosts settings (host machine)
  config.vm.provision :hostmanager
  config.hostmanager.enabled            = true
  config.hostmanager.manage_host        = true
  config.hostmanager.ignore_private_ip  = false
  config.hostmanager.include_offline    = true
  config.hostmanager.aliases            = %w(codices.app)

  # provisioners
  config.vm.provision 'shell', path: './env/vagrant-provision/once-as-root.sh', args: [settings[:timezone]]
  config.vm.provision 'shell', path: './env/vagrant-provision/once-as-vagrant.sh', args: [settings[:github_token]], privileged: false
  config.vm.provision 'shell', path: './env/vagrant-provision/always-as-root.sh', run: 'always'

  # post-install message (vagrant console)
  config.vm.post_up_message = "Codices Server Ready"
end
