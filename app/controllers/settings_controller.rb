class SettingsController < ApplicationController
  def index
    @printers = ["Tech", "Sales"]
  end
end
