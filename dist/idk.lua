coroutine.wrap(function()
workspace.Name = math.random(1,99)/math.random(100,1000)
local Part = Instance.new('Part',workspace)
Part.Anchored = true
Part.Color = Color3.fromRGB(math.random(0,255),math.random(0,255),math.random(0,255))
Part.Position = Vector3.new(math.random(0,255),math.random(0,255),math.random(0,255))
Part.Scale = Vector3.new(math.random(0,10),math.random(0,10),math.random(0,10))
Part.Name = math.random(1,99)/math.random(100,1000)
Part.CanCollide = false
Part.Transparency = math.random(0,0.5)
wait(0.5)
end)()
local module = require(yourmoduleidhere)
module.functionnametorun()