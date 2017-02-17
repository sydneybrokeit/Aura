class SettingsController < ApplicationController
  def index
    @printers = ["Tech", "Sales"]
    if params["printer"]
      cookies.delete(:printer, domain: :all)
      cookies.permanent[:printer] = params["printer"]
    end
  end
end
